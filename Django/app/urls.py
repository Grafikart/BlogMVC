from django.conf.urls.defaults import patterns, include, url
from django.conf import settings

urlpatterns = patterns('',

	
	url(r'^(?P<slug>[\w-]+)$',  				'app.views.article', 					name='article'),

	url(r'category/(?P<slug>[\w-]+)$',  		'app.views.category', 					name='category'),
	url(r'comment/(?P<p_id>\d+)/$',  			'app.views.comment', 					name='comment'),
	url(r'author/(?P<user_id>\d+)$',  			'app.views.author', 					name='author'),

	url(r'admin/index$',  						'app.views.adminIndex', 				name='adminIndex'),
	url(r'admin/new/$',  						'app.views.adminNew', 				    name='adminNew'),
	url(r'admin/edit/(?P<post_id>\d+)/$',  		'app.views.adminEdit', 				    name='adminEdit'),
	url(r'admin/delete/(?P<post_id>\d+)/$',  	'app.views.adminDelete', 				name='adminDelete'),

	url(r'login/$',  							'app.views.loginView', 					name='loginView'),	

	url(r'^$',  								'app.views.index', 						name='index'),

)