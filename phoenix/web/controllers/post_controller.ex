defmodule Blogmvc.PostController do

  use Blogmvc.Web, :controller
  alias Blogmvc.Post
  alias Blogmvc.Comment
  alias Blogmvc.Category

  def index(conn, params) do
    posts = get_posts(Post, params)
    render conn, "index.html", posts: posts
  end

  def category(conn, %{"slug" => slug} = params) do
    category = Repo.get_by!(Category, slug: slug)
    posts = Post
      |> where(category_id: ^category.id)
      |> get_posts(params)
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

  defp get_posts(query, params) do
    query
      |> preload([:user, :category])
      |> Repo.paginate(Map.put(params, :page_size, 2))
  end

end
