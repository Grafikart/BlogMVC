#-*- coding: utf-8 -*-
from django.conf.urls import patterns, include, url
from django.conf import settings

# Uncomment the next two lines to enable the admin:
from django.contrib import admin
admin.autodiscover()

urlpatterns = patterns('',
    url(r'^', include('blog.urls')),

    # Uncomment the admin/doc line below to enable admin documentation:
    url(r'^admin/doc/', include('django.contrib.admindocs.urls')),

    # Uncomment the next line to enable the admin:
    url(r'^admin/', include(admin.site.urls)),

)

# On active maintenant le service des fichiers statiques par Django
# mais uniquement en mode DEBUG (pour éviter de l'oublier en prod)
if settings.DEBUG:
    urlpatterns += patterns('',
        (r'%s/(?P<path>.*)$' % settings.MEDIA_URL.strip('/'),
         'django.views.static.serve',
         {'document_root': settings.MEDIA_ROOT}),
    )
