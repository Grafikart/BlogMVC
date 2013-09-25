from django.conf.urls import patterns, include, url
from blog.views import Home, PostDetails

urlpatterns = patterns('blog.views',
	url(r'^$', Home.as_view(), name="home"),
	url(r'^(?P<slug>[-\w]+)/$', PostDetails.as_view(), name="post_details"),
)
