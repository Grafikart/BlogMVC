defmodule Blogmvc.PostController do

  use Blogmvc.Web, :controller
  alias Blogmvc.Post
  alias Blogmvc.Comment
  alias Blogmvc.Category
  alias Blogmvc.User

  def index(conn, params) do
    posts = get_posts(Post, params)
    render conn, "index.html", posts: posts, page_title: suffix_page("My blog", params)
  end

  def category(conn, %{"slug" => slug} = params) do
    category = Repo.get_by!(Category, slug: slug)
    posts = Post
      |> where(category_id: ^category.id)
      |> get_posts(params)
    render conn, "index.html", posts: posts, page_title: suffix_page("Category : " <> category.name, params)
  end

  def author(conn, %{"id" => id} = params) do
    posts = Post
      |> where(user_id: ^id)
      |> get_posts(params)
    user = Repo.get!(User, id)
    render conn, "index.html", posts: posts, page_title: suffix_page("Posts by " <> user.username, params)
  end

  def show(conn, %{"slug" => slug}) do
    post = Repo.get_by!(preload(Post, [:user, :category, :comments]), slug: slug)
    comments_count = length(post.comments)
    comment = case is_nil(get_flash(conn, :changeset)) do
      true ->  Comment.changeset(%Comment{post_id: post.id})
      false -> get_flash(conn, :changeset)
    end
    render conn, :show, post: post, comment: comment, comments_count: comments_count, page_title: post.name
  end

  defp get_posts(query, params) do
    query
      |> preload([:user, :category])
      |> Repo.paginate(Map.put(params, :page_size, 1))
  end

  defp suffix_page(name, params) do
    if Map.has_key?(params, "page") && String.to_integer(params["page"]) > 1 do
      name <> ", page " <> params["page"]
    else
      name
    end
  end

end
