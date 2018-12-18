from django.shortcuts import render_to_response
from django.http import HttpResponse,StreamingHttpResponse
import urllib.request
from ModelDataBase.models import DataBaseAccount
from TOTP_WEB.checkpasswd import checkTOTP,checkNoTOTP
import random, string

def randomword(length):
   letters = string.ascii_lowercase
   return ''.join(random.choice(letters) for i in range(length))

def download(request):
	ID 		= request.GET["id"]
	passwd  = request.GET["passwd"]
	if (checkNoTOTP(ID,passwd)):
		#diplay in the html
		secret = randomword(16)
		#update table
		obj = DataBaseAccount.objects.get(account=ID)
		obj.sharkey= secret
		obj.save()
		return render_to_response("totp_buyed.html", {'secret':secret})
	else :
		return render_to_response('totp_buy.html')


'''def download(request):
	url0 	  = "11.txt"
	LocalPath ='./Document/Telecom/'
	urllib.request.urlretrieve(url0) 
	return HttpResponse("To be implented, download html")
'''
'''def download(request):
    # do something
    #the_file_name='Files/11.txt'             #显示在弹出对话框中的默认的下载文件名    
    filename='Files/11.txt'    #要下载的文件路径
    response=StreamingHttpResponse(readFile(filename))
    #urllib.request.urlretrieve(url)
    return response
 
def readFile(filename,chunk_size=512):
    with open(filename,'rb') as f:
        while True:
            c=f.read(chunk_size)
            if c:
                yield c
            else:
                break
'''
'''def download(request,f = "Files/11.txt"):
	t = f.split()
	file_name = t[-1]
	t.remove(t[-1])
	t.remove(t[0])
	file_path = '/'.join(t)
	def file_iterator(file_name,file_path,chunk_size=512):
		path = file_path +"/"+file_name
		with open(path) as f:
			while True:
				c = f.read(chunk_size)
				if c : 
					yield c 
				else :
					break
	try:
	    response = StreamingHttpResponse(file_iterator(file_name, file_path))
	    response['Content-Type'] = 'application/octet-stream'
	    response['Content-Disposition'] = 'attachment;filename="{0}"'.format(file_name)
	except:
		return HttpResponse("Sorry but not find the file")

	return reponse 
'''
