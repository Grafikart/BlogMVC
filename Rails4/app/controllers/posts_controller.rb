class PostsController < ApplicationController
  before_action :set_post, only: [:show, :edit, :update, :destroy]
  before_filter :authenticate_user!, except: [:show, :index]
  layout "admin", only: [:new, :edit, :create]

  # GET /posts
  # GET /posts.json
  def index
    @posts = Post.all.paginate(page: params[:page], per_page: 5)
  end

  # GET /posts/1
  # GET /posts/1.json
  def show
    @comment = Comment.new
    @comment.post_id = @post.id
  end

  # GET /posts/new
  def new
    @post = Post.new
  end

  # GET /posts/1/edit
  def edit
  end

  # POST /posts
  # POST /posts.json
  def create
    @post      = Post.new(post_params)

    respond_to do |format|
      if @post.save
        flash[:notice] = "Post was successfully created."
        format.html { redirect_to admin_path }
        format.json { render action: 'show', status: :created, location: @post }
      else
        format.html { render action: 'new' }
        format.json { render json: @post.errors, status: :unprocessable_entity }
      end
    end
  end

  # PATCH/PUT /posts/1
  # PATCH/PUT /posts/1.json
  def update
    respond_to do |format|
      if @post.update(post_params)
        format.html { redirect_to admin_path, notice: 'Post was successfully updated.' }
        format.json { head :no_content }
      else
        format.html { render action: 'edit' }
        format.json { render json: @post.errors, status: :unprocessable_entity }
      end
    end
  end

  # DELETE /posts/1
  # DELETE /posts/1.json
  def destroy
    @post.destroy
    respond_to do |format|
      format.html { redirect_to admin_url }
      format.json { head :no_content }
    end
  end

  def category
    @category = Category.friendly.find(params[:id])
    @posts = @category.posts.paginate(page: params[:page], per_page: 5)
  end

  def author
    @user = User.find(params[:id])
    @posts = @user.posts.paginate(page: params[:page], per_page: 5)
  end

  def add_comment
    @comment = Comment.new(comment_params)
    if @comment.save
      redirect_to @comment.post
    else
      @post = @comment.post
      render :show
    end
  end

  private
    # Use callbacks to share common setup or constraints between actions.
    def set_post
      @post = Post.friendly.find(params[:id])
    end

    # Never trust parameters from the scary internet, only allow the white list through.
    def post_params
      params.require(:post).permit!
    end

    def comment_params
      params.require(:comment).permit!
    end
end
