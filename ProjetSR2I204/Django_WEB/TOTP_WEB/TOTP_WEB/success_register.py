from django.shortcuts import render_to_response
from django.http import HttpResponse
from ModelDataBase.models import DataBaseAccount
from datetime import datetime
def insertData(request):
	if  ((request.GET["passwd"]       != "")):
		insertdata = DataBaseAccount(account  = request.GET['id'],\
								     birthday = request.GET['birthday'],\
							         passwd   = request.GET['passwd'],\
							         name     = request.GET['name'],\
							         sharkey  = 123456,\
							         timestamp= datetime.now() )
		insertdata.save()
		message = "you are successful to register a account"
		#test if database has receive the data insert
		'''list = DataBaseAccount.objects.all()
		response1=[]
		for var in list:
			response1 += var.passwd
		return HttpResponse(response1)
	    '''
	else :
		message = 'you did not complete the form'
	

    
	return HttpResponse(message)