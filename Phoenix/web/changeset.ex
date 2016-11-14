defmodule Blogmvc.Changeset do
  @moduledoc ~S"""
  Update count field for a specific association
  """
  alias Ecto.Changeset
  import Ecto.Query

  @spec update_count(Ecto.Changeset.t, Atom.t, Atom.t) :: Ecto.Changeset.t
  def update_count(changeset, assoc, field) do
    association = Ecto.Association.association_from_schema!(changeset.data.__struct__, assoc)
    owner_key = association.owner_key
    new_value = Changeset.get_change(changeset, owner_key)
    if new_value do
      changeset
        |> Changeset.prepare_changes(fn changeset ->
          # We decrement the current associated record
          if Map.get(changeset.data, owner_key) do
            Ecto.assoc(changeset.data, assoc)
              |> changeset.repo.update_all(inc: [{field, -1}])
          end
          # We increment the new associated record
          association.queryable
            |> where(^[{association.related_key, new_value}])
            |> changeset.repo.update_all(inc: [{field, 1}])
          changeset
        end)
    else
      changeset
    end
  end

  @spec update_count(Ecto.Changeset.t, Atom.t, Atom.t, Integer.t) :: Ecto.Changeset.t
  def update_count(changeset, assoc, field, value) do
    changeset
      |> Changeset.prepare_changes(fn changeset ->
        # We decrement/increment the current associated record
        Ecto.assoc(changeset.data, assoc)
          |> changeset.repo.update_all(inc: [{field, value}])
        changeset
      end)
  end
end