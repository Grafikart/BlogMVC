package models;

import org.hibernate.annotations.Type;
import org.hibernate.validator.constraints.NotEmpty;
import org.joda.time.DateTime;
import play.Logger;
import play.db.jpa.JPA;

import javax.persistence.CascadeType;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.ManyToOne;
import javax.persistence.OneToMany;
import javax.persistence.OneToOne;
import javax.persistence.OrderBy;
import javax.persistence.TypedQuery;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by greg on 16/09/2016.
 */

@Entity
public class Posts {

  @Id
  @GeneratedValue(strategy = GenerationType.TABLE)
  public Long id;
  @ManyToOne
  public Categories categories;
  @ManyToOne
  public Users user;
  @OneToMany(mappedBy = "post", cascade = CascadeType.ALL)
  @OrderBy("created DESC")
  public List<Comments> associatedComments;

  @NotEmpty
  public String name;
  @OneToOne(cascade = CascadeType.ALL)
  public Slug slug;
  @Column(columnDefinition = "TEXT")
  public String contents;
  @Type(type = "org.jadira.usertype.dateandtime.joda.PersistentDateTime") //Store in timestamp form instead of bytes in db
  public DateTime created;

  public Posts() {
    this.id = 0L;
    this.name = "";
    this.slug = null;
    this.contents = "";
  }


  public static Posts find(Long id) {
    try {
      return JPA.em().createQuery("SELECT p FROM Posts p WHERE p.id = :id", Posts.class)
          .setParameter("id", id)
          .getSingleResult();
    } catch (Exception e) {
      Logger.error(e.getMessage());
      return null;
    }
  }

  public static List<Posts> findAll() {
    try {
      return JPA.em().createQuery("SELECT p FROM Posts p ORDER BY p.created DESC", Posts.class).getResultList();
    } catch (Exception e) {
      Logger.error(e.getMessage());
      return new ArrayList<>();
    }
  }

  public static List<Posts> findAllByAuthor(Users user) {
    return findAllByAuthorFrom(user, 0, 0);
  }

  public static List<Posts> findAllByAuthorFrom(Users user, Integer from, Integer limit) {
    try {
      TypedQuery<Posts> query = JPA.em().createQuery("SELECT p FROM Posts p WHERE p.user =:user ORDER BY p.created DESC", Posts.class)
          .setFirstResult(from)
          .setParameter("user", user);
      if (limit != 0) {
        query = query.setMaxResults(limit);
      }
      return query.getResultList();
    } catch (Exception e) {
      Logger.error(e.getMessage());
      return new ArrayList<>();
    }
  }

  public static List<Posts> findAllByCategories(Categories c) {
    return findAllByCategoriesFrom(c, 0, 0);
  }

  public static List<Posts> findAllByCategoriesFrom(Categories categories, Integer from, Integer limit) {
    try {
      TypedQuery<Posts> query = JPA.em().createQuery("SELECT p FROM Posts p WHERE p.categories =:c ORDER BY p.created DESC", Posts.class)
          .setFirstResult(from)
          .setParameter("c", categories);
      if (limit != 0) {
        query = query.setMaxResults(limit);
      }
      return query.getResultList();
    } catch (Exception e) {
      Logger.error(e.getMessage());
      return new ArrayList<>();
    }
  }


  public static List<Posts> findLastFivePost() {
    try {
      return JPA.em().createQuery("SELECT p FROM Posts p ORDER BY p.created DESC", Posts.class)
          .setMaxResults(5)
          .getResultList();
    } catch (Exception e) {
      Logger.error(e.getMessage());
      return new ArrayList<>();
    }
  }

  public static List<Posts> findFivePostFrom(Integer startPosition) {
    try {
      return JPA.em().createQuery("SELECT p FROM Posts p ORDER BY p.created DESC", Posts.class)
          .setFirstResult(startPosition)
          .setMaxResults(5)
          .getResultList();
    } catch (Exception e) {
      Logger.error(e.getMessage());
      return new ArrayList<>();
    }
  }
}
