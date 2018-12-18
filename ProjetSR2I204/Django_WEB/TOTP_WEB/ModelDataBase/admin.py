from django.contrib import admin

# Register your models here.
from ModelDataBase import models
class DataBaseAdmin(admin.ModelAdmin):
	list_display = ('account','timestamp')
admin.site.register(models.DataBaseAccount, DataBaseAdmin)
