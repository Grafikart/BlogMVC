from django.shortcuts 		import render_to_response
from django.template 		import Context, Template, RequestContext
from django.http 			import HttpResponseRedirect, HttpResponse
from django.contrib.auth 	import authenticate, login

from django.core.paginator 				import Paginator, EmptyPage, PageNotAnInteger
from django.contrib.auth.decorators 	import login_required
from datetime 							import datetime,timedelta

from app.models 	import *

def get_posts(posts, page):
	""" get post by pagination """
	paginator = Paginator(posts, 5) # Show 25 posts per page

	try:
		posts = paginator.page(page)
	except PageNotAnInteger:
		# If page is not an integer, deliver first page.
		posts = paginator.page(1)
	except EmptyPage:
		# If page is out of range (e.g. 9999), deliver last page of results.
		posts = paginator.page(paginator.num_pages)

	return posts

def index(request):
	""" index page """
	posts 	= Post.objects.all()
	page 	= request.GET.get('page')

	data = {}
	data['articles'] 		= get_posts(posts, page)
	data['categories'] 		= Categorie.objects.all()
	return render_to_response('index.html', data , context_instance=RequestContext(request))

def article(request, slug):
	""" single article view """
	data 		= {}
	post 		= Post.objects.filter(slug = slug)
	if post.count() > 0 :
		post = post[0]
		data['post'] 			= post
		data['comments']    	= post.comments.all()
		data['categories'] 		= Categorie.objects.all()
		
		return render_to_response('post.html', data , context_instance=RequestContext(request))
	else :
		return HttpResponseRedirect("/")

def comment(request, p_id) :
	""" comment a post """
	data 				= {}
	post 				= Post.objects.filter(id = p_id)
	if post.count() > 0 :
		post = post[0]
		mail 			= request.POST.get('email', '')
		username 		= request.POST.get('username', '')
		content 		= request.POST.get('content', '')

		if len(mail) > 0 and len(username) > 0 :
			comment = Comment(mail = mail, username=username, content=content, created = datetime.now(), post = post )
			comment.save()

			request.session['has_commented'] = True
		else :
			request.session['comment_error'] = True

		return HttpResponseRedirect("/" + post.slug )
	else :
		return HttpResponseRedirect("/")

def category(request, slug):
	""" category post """
	categorie 	= Categorie.objects.get(slug = slug)
	posts 	  	= Post.objects.filter(categorie = categorie)
	page 		= request.GET.get('page')

	data = {}
	data['articles'] 		= get_posts(posts, page)
	data['categories'] 		= Categorie.objects.all()
	return render_to_response('index.html', data , context_instance=RequestContext(request))

def author(request, user_id):
	""" author post """
	posts 	  	= Post.objects.filter(user__id = user_id)
	page 		= request.GET.get('page')

	data = {}
	data['articles'] 		= get_posts(posts, page)
	data['categories'] 		= Categorie.objects.all()
	return render_to_response('index.html', data , context_instance=RequestContext(request))

def loginView(request):
	""" login view access to admin pages """
	if request.POST :
		username = request.POST.get('username', '')
		password = request.POST.get('password', '')
		user = authenticate(username=username, password=password)
		if user is not None:
			if user.is_active:
				login(request, user)
				return HttpResponseRedirect('/admin/index/')
			else:
				return HttpResponseRedirect('/')
		else:
			return HttpResponseRedirect('/')
	else :
		data = {}
		return render_to_response('login.html' , data , context_instance=RequestContext(request))

@login_required
def adminIndex(request):
	""" admin index view """
	data 	= {}
	posts 	= Post.objects.all()
	page 	= request.GET.get('page')

	data = {}
	data['admin']			= True
	data['articles'] 		= get_posts(posts, page)
	return render_to_response('admin/index.html' , data , context_instance=RequestContext(request))

@login_required
def adminEdit(request, post_id = 0):
	if request.POST :
		""" post data, we update the post """
		post_id     		= request.POST.get('postID', '')
		
		cat_id 				= request.POST.get('PostCategoryId', '')
		usr_id 				= request.POST.get('PostUserId', '')

		post 				= Post.objects.get(id = post_id)
		post.name   		= request.POST.get('PostName', '')
		post.slug 			= request.POST.get('PostSlug', '')
		post.user   		= User.objects.get(id = usr_id)
		post.categorie 		= Categorie.objects.get(id = cat_id)
		post.content 		= request.POST.get('PostContent', '')
		post.save()

		return HttpResponseRedirect("/admin/index")

	else :
		""" no post data, this is simple view access """
		data = {}
		post = Post.objects.get(id = post_id)

		data['categories'] 		= Categorie.objects.all()
		data['users'] 			= User.objects.all()
		data['admin']			= True
		data['post'] 			= post
		return render_to_response('admin/edit.html' , data , context_instance=RequestContext(request))

@login_required
def adminNew(request, post_id = 0):
	if request.POST :
		""" post data, we add the post """	
		cat_id 				= request.POST.get('PostCategoryId', '')
		usr_id 				= request.POST.get('PostUserId'	   , '')
		name   				= request.POST.get('PostName'      , '')
		slug 				= request.POST.get('PostSlug'      , '')
		content 			= request.POST.get('PostContent'   , '')

		user   				= User.objects.get(id = usr_id)
		categorie 			= Categorie.objects.get(id = cat_id)

		post 				= Post(name = name, slug = slug, user = user, categorie = categorie, content = content)
		post.save()

		return HttpResponseRedirect("/admin/index")

	else :
		""" no post data, this is simple view access """
		data = {}

		data['categories'] 		= Categorie.objects.all()
		data['users'] 			= User.objects.all()
		data['admin']			= True
		return render_to_response('admin/edit.html' , data , context_instance=RequestContext(request))

@login_required
def adminDelete(request, post_id = 0):
	""" delete a post """
	if post_id > 0 :
		post 		= Post.objects.filter(id = post_id)
		if post.count() > 0 :
			post = post[0]
			post.delete()

	return HttpResponseRedirect("/admin/index")


