#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Tue Dec  4 19:35:21 2018

@author: ubuntu
"""
import  pyotp

totp = pyotp.TOTP("TPTsdsqd")
totp1 = totp.now()
print(totp1)

verify = totp.verify(totp1)
print(verify)