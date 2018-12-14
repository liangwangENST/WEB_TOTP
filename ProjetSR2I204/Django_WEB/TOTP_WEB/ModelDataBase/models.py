from django.db import models

# Create your models here.
#table DataBaseAccount
class DataBaseAccount(models.Model):
	account 		 = models.CharField(max_length =30)
	name     		 = models.CharField(max_length=30)
	birthday         = models.CharField(max_length=30)
	passwd           = models.CharField(max_length=30)
	sharkey          = models.CharField(max_length=1000)

	def __str__(self):
		return self.account