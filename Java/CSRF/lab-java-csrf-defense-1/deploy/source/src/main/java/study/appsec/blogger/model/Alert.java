package study.appsec.blogger.model;

import lombok.Getter;
import lombok.RequiredArgsConstructor;
import lombok.Setter;

import java.io.Serializable;

@Setter
@Getter
@RequiredArgsConstructor
public class Alert implements Serializable {

    private static final long serialVersionUID = 1L;

    public static final String STYLE_SUCCESS = "success";
    public static final String STYLE_INFO = "info";
    public static final String STYLE_WARNING = "warning";
    public static final String STYLE_DANGER = "danger";

    private final String keyword;

    private final String text;

    private final String style;

}
