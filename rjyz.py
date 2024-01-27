from django.shortcuts import render
from django.http import HttpResponse,JsonResponse
from django.views.decorators.csrf import csrf_exempt
from v1.util.token_store import cf_key
import json
import requests

@csrf_exempt
def cf_captcha(request):
    if not cf_captcha_verify(request):
        return JsonResponse({"err": "verify failed"})
    request.session["has_verified"] = 1 # 在session中设置一个key
    request.session.set_expiry(7200) # expires 2 hours
    print("set verified")
    return JsonResponse({"err": ""})

def cf_captcha_verify(request):
    url = "https://challenges.cloudflare.com/turnstile/v0/siteverify"
    token = request.POST.get("verify_token")
    client_ip = request.META.get('REMOTE_ADDR') # 获取请求的IP地址
    form_data = {
        "secret": cf_key,
        "response": token,
        "remoteip": client_ip,
    }
    resp = requests.post(url, json=form_data)
    if resp.status_code != 200:
        print("response err, verify failed")
        return False
    resp_json = json.loads(resp.content)
    if resp_json["success"]:
        return True
    else:
        print("verify failed:", resp_json)
    return False