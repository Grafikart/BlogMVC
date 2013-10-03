import os
import sys
 
sys.path.append('/var/www/blogMVC/BlogMVC/Django')
 
os.environ['DJANGO_SETTINGS_MODULE'] = 'Django.settings'
 
import django.core.handlers.wsgi
application = django.core.handlers.wsgi.WSGIHandler()
