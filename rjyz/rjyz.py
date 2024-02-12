import gvcode
import os
import hashlib

s,v = gvcode.generate()
md5 = hashlib.md5()
data = v
md5.update(data.encode('utf-8'))
print(md5.hexdigest())
hash_1=str(md5.hexdigest())
s.save('%s.jpg' % v)
print(type(s))
print(v)
print(type(v))


with open('code.txt','w') as f:
    f.write(v+'\n'+md5.hexdigest())
    