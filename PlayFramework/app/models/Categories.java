package models;

import play.Logger;
import play.db.jpa.JPA;

import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.OneToMany;
import javax.persistence.OneToOne;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by greg on 16/09/2016.
 */

@Entity
public class Categories {

  @Id
  @GeneratedValue(strategy = GenerationType.AUTO)
  public Long id;
  public String name;
  @OneToOne
  public Slug slug;
  @OneToMany(mappedBy = "categories")
  public List<Posts> associatedPost;

  public static Categories find(Long id) {
    try {
      return JPA.em().createQuery("SELECT c FROM Categories c WHERE c.id = :id", Categories.class).setParameter("id", id).getSingleResult();
    } catch (Exception e) {
      Logger.error(e.getMessage());
      return null;
    }
  }

  public static Categories find(String name) {
    try {
      return JPA.em().createQuery("SELECT c FROM Categories c WHERE c.name = :name", Categories.class).setParameter("name", name).getSingleResult();
    } catch (Exception e) {
      Logger.error(e.getMessage());
      return null;
    }
  }

  public static List<Categories> findAll() {
    try {
      return JPA.em().createQuery("SELECT c FROM Categories c", Categories.class).getResultList();
    } catch (Exception e) {
      Logger.error(e.getMessage());
      return new ArrayList<>();
    }
  }
}
