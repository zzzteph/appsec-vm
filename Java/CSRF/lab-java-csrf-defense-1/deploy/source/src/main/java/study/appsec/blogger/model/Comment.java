package study.appsec.blogger.model;

import lombok.Getter;
import lombok.Setter;
import lombok.experimental.Accessors;
import org.hibernate.annotations.Cache;
import org.hibernate.annotations.CacheConcurrencyStrategy;
import org.hibernate.validator.constraints.Length;

import javax.persistence.*;
import java.util.Date;

@Setter
@Getter
@Accessors(chain = true)

@Entity
@Table(name = "`comment`")
@Cache(usage = CacheConcurrencyStrategy.READ_WRITE)
public class Comment extends BaseModel {

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "`post_id`")
    private Post post;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "`user_id`")
    private User user;

    @Column
    @Length(min = 10, max = 10000)
    private String text;

    @Temporal(TemporalType.TIMESTAMP)
    @Column(name = "`date_created`")
    private Date dateCreated;

}
