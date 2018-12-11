from django.shortcuts import render_to_response
from django.http import HttpResponse

def display(request):
	return HttpResponse("you are successful to register a account")