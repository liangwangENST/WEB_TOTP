from django.http import HttpResponse
from django.shortcuts import render_to_response

def display(request):
	return render_to_response("validate_login.html")