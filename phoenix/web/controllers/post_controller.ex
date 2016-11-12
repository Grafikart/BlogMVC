defmodule Blogmvc.PostController do

  use Blogmvc.Web, :controller
  alias Blogmvc.Post
  alias Blogmvc.Comment

  def index(conn, params) do
    posts = Post
      |> preload([:user, :category])
      |> Repo.paginate(Map.put(params, :page_size, 2))
    render conn, "index.html", posts: posts
  end

  def show(conn, %{"slug" => slug}) do
    post = Repo.get_by!(preload(Post, [:user, :category, :comments]), slug: slug)
    comment = case is_nil(get_flash(conn, :changeset)) do
      true ->  Comment.changeset(%Comment{post_id: post.id})
      false -> get_flash(conn, :changeset)
    end
    render conn, :show, post: post, comment: comment
  end

end
