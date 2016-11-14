defmodule Blogmvc.CommentController do

  use Blogmvc.Web, :controller
  alias Blogmvc.Comment
  alias Blogmvc.Post

  def create(conn, %{"comment" => comment_params} = params) do
    post_id = String.to_integer(params["post_id"])
    post = Repo.get!(Post, post_id)
    changeset = Comment.changeset(%Comment{post_id: post_id}, comment_params)

    case Repo.insert(changeset) do
      {:ok, _comment } ->
        conn |> put_flash(:success, "Thanks for your comment")
      {:error, changeset} ->
        conn
          |> put_flash(:changeset, changeset)
          |> put_flash(:error, "Oops Something Wrong")
    end
      |> redirect(to: post_path(conn, :show, post.slug) <> "#commentForm")
  end

end
