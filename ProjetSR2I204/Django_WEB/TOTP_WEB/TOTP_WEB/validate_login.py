from django.http import HttpResponse
from django.shortcuts import render_to_response
from TOTP_WEB.checkpasswd import *

def display(request):
	ID     = request.GET['id']
	passwd = request.GET['password']
	TOTP   = request.GET['totp']
	print("validate_looginID",ID)
	print("validate_looginpasswd",passwd)
	print("validate_looginTOTP", TOTP)
	if (checkTOTP(ID, passwd, TOTP)):
		return render_to_response("validate_login.html")
	else:
		return render_to_response("fail_login.html")