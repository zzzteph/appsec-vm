package study.appsec.blogger.model;

import lombok.Getter;
import lombok.Setter;
import lombok.experimental.Accessors;
import org.hibernate.annotations.Cache;
import org.hibernate.annotations.CacheConcurrencyStrategy;
import org.hibernate.validator.constraints.Length;

import javax.persistence.*;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

@Setter
@Getter
@Accessors(chain = true)

@Entity
@Table(name = "`opinion`")
@Cache(usage = CacheConcurrencyStrategy.READ_WRITE)
public class Opinion extends BaseModel {

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "`post_id`")
    private Post post;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "`user_id`")
    private User user;

    @Column
    private Integer value;

}
