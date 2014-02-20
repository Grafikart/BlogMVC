class Home::CommentsController < Home::HomeController
	def create
		@comment = Comment.new(comment_params)
		@post = Post.find(params[:comment][:post_id])
		if @comment.save
			flash[:message] = "Post was successfully created."
			redirect_to @comment.post
		else
			render 'home/posts/show'
		end
	end

	private
	
    def comment_params
    	if current_user
			params.require(:comment).permit!
		end
	end
	

end