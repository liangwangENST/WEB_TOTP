from django.shortcuts import render_to_response

def display(request):
	return render_to_response("totp_buy.html")