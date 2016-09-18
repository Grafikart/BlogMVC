package models;

import play.Logger;
import play.db.jpa.JPA;

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

  public static Slug find(String slug) {
    try {
      return JPA.em().find(Slug.class, slug);
    } catch (Exception e) {
      Logger.error(e.getMessage());
      return null;
    }
  }
}
