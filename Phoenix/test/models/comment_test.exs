defmodule Blogmvc.CommentTest do
  use Blogmvc.ModelCase

  alias Blogmvc.Comment

  @valid_attrs %{content: "some content", mail: "some content", username: "some content"}
  @invalid_attrs %{}

  test "changeset with valid attributes" do
    changeset = Comment.changeset(%Comment{}, @valid_attrs)
    assert changeset.valid?
  end

  test "changeset with invalid attributes" do
    changeset = Comment.changeset(%Comment{}, @invalid_attrs)
    refute changeset.valid?
  end
end
