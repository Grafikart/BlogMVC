package models;

import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.OneToOne;

/**
 * Created by greg on 17/09/2016.
 */

@Entity
public class Slug {
  @Id
  public String name;

  @OneToOne
  public Categories categorie;
  @OneToOne
  public Posts post;

}
