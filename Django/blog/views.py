from blog.models import Post
from django.views.generic import ListView

class Home(ListView):
	model               = Post
	context_object_name = "posts"
	template_name       = "blog/home.html"
	paginate_by         = 5

class PostDetails(ListView):
	model               = Post
	context_object_name = "posts"
	template_name       = "blog/post_details.html"
	paginate_by         = 5

	def get_queryset(self):
		return Post.objects.filter(post__slug=self.args[0])