defmodule Blogmvc.Admin.PostControllerTest do
  use Blogmvc.ConnCase

  alias Blogmvc.Admin.Post
  @valid_attrs %{content: "some content", name: "some content", slug: "some content"}
  @invalid_attrs %{}

  test "lists all entries on index", %{conn: conn} do
    conn = get conn, post_path(conn, :index)
    assert html_response(conn, 200) =~ "Listing posts"
  end

  test "renders form for new resources", %{conn: conn} do
    conn = get conn, post_path(conn, :new)
    assert html_response(conn, 200) =~ "New post"
  end

  test "creates resource and redirects when data is valid", %{conn: conn} do
    conn = post conn, post_path(conn, :create), post: @valid_attrs
    assert redirected_to(conn) == post_path(conn, :index)
    assert Repo.get_by(Post, @valid_attrs)
  end

  test "does not create resource and renders errors when data is invalid", %{conn: conn} do
    conn = post conn, post_path(conn, :create), post: @invalid_attrs
    assert html_response(conn, 200) =~ "New post"
  end

  test "shows chosen resource", %{conn: conn} do
    post = Repo.insert! %Post{}
    conn = get conn, post_path(conn, :show, post)
    assert html_response(conn, 200) =~ "Show post"
  end

  test "renders page not found when id is nonexistent", %{conn: conn} do
    assert_error_sent 404, fn ->
      get conn, post_path(conn, :show, -1)
    end
  end

  test "renders form for editing chosen resource", %{conn: conn} do
    post = Repo.insert! %Post{}
    conn = get conn, post_path(conn, :edit, post)
    assert html_response(conn, 200) =~ "Edit post"
  end

  test "updates chosen resource and redirects when data is valid", %{conn: conn} do
    post = Repo.insert! %Post{}
    conn = put conn, post_path(conn, :update, post), post: @valid_attrs
    assert redirected_to(conn) == post_path(conn, :show, post)
    assert Repo.get_by(Post, @valid_attrs)
  end

  test "does not update chosen resource and renders errors when data is invalid", %{conn: conn} do
    post = Repo.insert! %Post{}
    conn = put conn, post_path(conn, :update, post), post: @invalid_attrs
    assert html_response(conn, 200) =~ "Edit post"
  end

  test "deletes chosen resource", %{conn: conn} do
    post = Repo.insert! %Post{}
    conn = delete conn, post_path(conn, :delete, post)
    assert redirected_to(conn) == post_path(conn, :index)
    refute Repo.get(Post, post.id)
  end
end
