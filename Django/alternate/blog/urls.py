from django.conf.urls import patterns, include, url
from blog.views import ListHomePosts, PostDetails, ListPostsByCategory, ListPostsByUser, comment

urlpatterns = patterns('blog.views',
	url(r'^$', ListHomePosts.as_view(), name="home"),
	url(r'^(?P<slug>[-\w]+)/$', PostDetails.as_view(), name="post_details"),
	url(r'^category/(?P<slug>[-\w]+)/$', ListPostsByCategory.as_view(), name="post_category"),
	url(r'^author/(?P<id>[-\d]+)/$', ListPostsByUser.as_view(), name="post_user"),
	url(r'^comment/(?P<post_id>[-\d]+)/$', comment, name="comment"),
)
