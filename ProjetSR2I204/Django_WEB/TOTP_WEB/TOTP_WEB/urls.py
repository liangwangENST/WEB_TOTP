"""TOTP_WEB URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/2.1/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.conf.urls import url
from . import login,register,totp_buy,success_register,validate_login,\
fail_login, totpdownload,archive
from django.conf.urls.static import static
from TOTP_WEB import settings
from django.contrib import admin


admin.autodiscover()
urlpatterns = [
    url(r'^admin'                , admin.site.urls),
    url(r'^login$'                , login.display),
    url(r'^register$'             , register.display),
    url(r'^buy$'                  , totp_buy.display),
    url(r'^totp-buyed$'			  , totpdownload.download),
    url(r'^success-register$'     , success_register.insertData),
    url(r'^validate-login$'       , validate_login.display),
    #url(r'^fail-login$'           , fail_login.display),
    #url(r'^$',upload),
    #url(r'^uploads', uploads, name ="uploads"),
    url(r'download/(?P<f>.*)$'    , totpdownload.download , name = 'download' ),
    url(r'archive'                , archive.archive ),
]

