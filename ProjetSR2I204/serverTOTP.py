#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Mon Dec  3 22:38:13 2018

@author: ubuntu
"""
import http.server
import os

class case_no_file(object):
    '''该路径不存在'''

    def test(self, handler):
        return not os.path.exists(handler.full_path)

    def act(self, handler):
        raise ServerException("'{0}' not found".format(handler.path))


class case_existing_file(object):
    '''该路径是文件'''

    def test(self, handler):
        return os.path.isfile(handler.full_path)
        
    def act(self, handler):
        handler.handle_file(handler.full_path)
        

class case_always_fail(object):
    '''所有情况都不符合时的默认处理类'''

    def test(self, handler):
        return True

    def act(self, handler):
        raise ServerException("Unknown object '{0}'".format(handler.path))
        
        
        
        
class ServerException(Exception):
        pass
    
class ResquestHandler(http.server.BaseHTTPRequestHandler):
    
    Cases = [case_no_file(),
             case_existing_file(),
             case_always_fail()]
    # 处理一个GET请求
    def do_GET(self):
        try:
            full_path = os.getcwd() +self.path   
            if not os.path.exists(full_path):
            #抛出异常：文件未找到
                raise ServerException("'{0}' not found".format(self.path))

        # 如果该路径是一个文件
            elif os.path.isfile(full_path):
            #调用 handle_file 处理该文件
                self.handle_file(full_path)

        # 如果该路径不是一个文件
            else:
            #抛出异常：该路径为不知名对象
                raise ServerException("Unknown object '{0}'".format(self.path))
        
               
        except Exception as msg:
           self.handle_error(msg)
    
    def send_content(self, page,status=200):
        self.send_response(200)
        self.send_header("Content-type", "text/html")
        self.send_header("Content-Length", str(len(page)))
        self.end_headers()
        self.wfile.write(page)
    
    def handle_file(self, full_path):
        try:
            print("TEST")
            with open(full_path, 'rb') as reader:
                content = (reader.read())      
            self.send_content(content)
        except IOError as msg:
            msg = "'{0}' cannot be read: {1}".format(self.path, msg)
            self.handle_error(msg)  

    def handle_error(self, msg):
        try :
            with open(os.getcwd()+'/error_page.html', 'rb') as reader:
                content = reader.read()
                self.send_content(content)
        except IOError as msg:
            msg = "'{0}' cannot be read: {1}".format(self.path, msg)
            self.handle_error(msg)  
    
if __name__ == '__main__':
    serverAddress = ('', 8918)
    server = http.server.HTTPServer(serverAddress, ResquestHandler)
    server.serve_forever()   

