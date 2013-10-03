from blog.models import Post, Comment
from django.views.generic import ListView, DetailView
from blog.forms import CommentForm
from django.shortcuts import render
from django.http import HttpResponseRedirect
from django.core.urlresolvers import reverse

class ListHomePosts(ListView):
	model               = Post
	context_object_name = "posts"
	template_name       = "blog/home.html"
	paginate_by         = 5

	def get_context_data(self, **kwargs):
		context = super(ListHomePosts, self).get_context_data(**kwargs)
		context['header']    = 'Blog'
		context['subheader'] = 'Welcome on my blog'
		return context

class ListPostsByCategory(ListView):
	model               = Post
	context_object_name = "posts"
	template_name       = "blog/home.html"
	paginate_by         = 5

	def get_queryset(self):
		return Post.objects.filter(category__slug=self.kwargs['slug'])

class ListPostsByUser(ListView):
	model               = Post
	context_object_name = "posts"
	template_name       = "blog/home.html"
	paginate_by         = 5

	def get_queryset(self):
		return Post.objects.filter(user__id=self.kwargs['id'])

class PostDetails(DetailView):
	model               = Post
	context_object_name = "post"
	template_name       = "blog/post_details.html"

def comment(request, post_id):
	if request.method == 'POST':
		post_obj = Post.objects.get(id = post_id)
		mail     = request.POST.get('mail')
		username = request.POST.get('username')
		message  = request.POST.get('message')
		post     = request.POST.get('post', post_id)

		data = {
			'mail'     : mail,
			'username' : username,
			'message'  : message,
			'post'     : post_id
		}

		form = CommentForm(data)

		if form.is_valid():
			comment = Comment(mail= mail, username=username, message=message, post=post_obj)
			comment.save()
			request.session['comment_error']   = False
			request.session['comment_success'] = True
		else:
			request.session['comment_success'] = False
			request.session['comment_error']   = True
	else:
		form = CommentForm()

	return HttpResponseRedirect(reverse('post_details', kwargs={'slug': post_obj.slug}))