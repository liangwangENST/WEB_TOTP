from datetime import datetime
from django.shortcuts import render_to_response,render
from ModelDataBase.models import DataBaseAccount

def archive(request):
	posts = DataBaseAccount(account 		= 'liang.wang@gmail.com',\
						   name 	    = '1wang',\
						   timestamp    =  datetime.now())
	string = 'HACK ME '
	return render(request,'archive.html', \
			{'posts':[posts]},\
			{'string':string})