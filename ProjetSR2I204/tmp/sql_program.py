#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Tue Dec  4 20:24:27 2018

@author: ubuntu
"""
import sqlite3

def create_table():    
    conn = sqlite3.connect('booklet.db')
    print ("Opened database successfully");
    c    = conn.cursor()
    c.execute('''CREATE TABLE book(id,passwd,name,birthday,sharekey)''')
    conn.commit()
    
def insert_values():
    conn = sqlite3.connect('booklet.db')
    print ("Opened database successfully");
    c    = conn.cursor()
    c.execute('''INSERT INTO book values('id001','id001','wangliang',20180105,'XXXXX')''')
    conn.commit()
    conn.close()
    
def display_tables():
    conn = sqlite3.connect('booklet.db')
    print ("Opened database successfully");
    c    = conn.cursor()
    c.execute('SELECT * FROM book')
    print(c.fetchall())
    
    
if __name__=='__main__':  
    display_tables()
    