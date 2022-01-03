package study.appsec;

import org.springframework.boot.builder.SpringApplicationBuilder;
import org.springframework.boot.web.servlet.support.SpringBootServletInitializer;

public class Servlet extends SpringBootServletInitializer {

  @Override
  protected SpringApplicationBuilder configure(SpringApplicationBuilder springApplicationBuilder) {
    return springApplicationBuilder.sources(PathApplication.class);
  }
}
