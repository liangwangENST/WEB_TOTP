#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Tue Dec  4 19:35:21 2018

@author: ubuntu
"""
import  pyotp
from datetime import datetime
def generatorTOTP(sharkey):
	totp = pyotp.TOTP("sharkey")
	totp1 = totp.now()
	print(totp1)
	print(datetime.now())
	return totp1
#def checkTOTP(value_totp)
#	verify = totp.verify(value_totp)
#s	return verify
if __name__ == '__main__':
	a =generatorTOTP("SSSSSSSSSSSSSSSS")
