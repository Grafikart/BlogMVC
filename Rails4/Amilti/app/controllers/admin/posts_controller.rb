class Admin::PostsController < Admin::AdminController

	def index
		@posts = Post.order('created_at DESC').page(params[:page]).per(5)
	end

	def new
		@post = Post.new
	end

	def create
		@post = Post.new(post_params)
      	if @post.save
			flash[:message] = "Post was successfully created."
			redirect_to admin_posts_path
      	else
			render action: 'new'
		end
	end

	def edit
		@post = Post.find(params[:id])
	end

	def update
		@post = Post.friendly.find(params[:id])
		@post.update_attributes(post_params)
		if @post.save
			redirect_to admin_posts_path
		else
			render action: 'edit'
		end
	end

	def destroy
		post = Post.find(params[:id])
		post.destroy
		redirect_to :back
	end

	private
    	def post_params
    		if current_user
				params.require(:post).permit!
			end
		end
	
end