from django.http import HttpResponse
from ModelDataBase.models import DataBaseAccount
from TOTP_WEB.TOTP import *

def checkNoTOTP(ID,password):
	compte = DataBaseAccount.objects.get(account = ID)
	if(compte.passwd==password):
		return True
	else:
		return False

def checkTOTP(ID,passwd,TOTP):
	compte = DataBaseAccount.objects.get(account = ID)
	#print("checktotp:",compte.passwd)
	#print("checktotp:",get_totp_token(compte.sharkey))
	
	if(compte.passwd==passwd):
		print("password correct")
		if (str(get_totp_token(compte.sharkey))==TOTP):# be careful for the type of string or int 
		   	  return True
		else:
			#print('________________________________')
			#print(get_totp_token(compte.sharkey))
			#print(TOTP)
			#print(type(get_totp_token(compte.sharkey)))
			#print(type(TOTP))
			return False 
	else:
		return HttpResponse("password not validate")