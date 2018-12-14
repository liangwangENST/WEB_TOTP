from django.http import HttpResponse
from django.shortcuts import render_to_response

def display(request):
	if (request.GET['totp'] or True):
		return render_to_response("validate_login.html")
	else:
		return render_to_response("fail_login.html")