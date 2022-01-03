package study.appsec.blogger.controller;

import study.appsec.blogger.model.Post;
import study.appsec.blogger.model.User;
import study.appsec.blogger.service.OpinionService;
import study.appsec.blogger.service.PostService;
import study.appsec.blogger.service.UserService;
import lombok.RequiredArgsConstructor;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;

import java.security.Principal;

@Controller
@RequiredArgsConstructor
public class OpinionController extends BaseController {

    private final UserService userService;
    private final PostService postService;
    private final OpinionService opinionService;

    @PostMapping("/like/{postId}")
    public String like(@AuthenticationPrincipal Principal principal, @PathVariable Long postId,
                       @RequestParam int value) {
        handleOpinionChange(principal, postId, value);
        return redirect("/post/" + postId);
    }

    @PostMapping("/dislike/{postId}")
    public String dislike(@AuthenticationPrincipal Principal principal, @PathVariable Long postId,
                          @RequestParam int value) {
        handleOpinionChange(principal, postId, value);
        return redirect("/post/" + postId);
    }

    private void handleOpinionChange(Principal principal, Long postId, int value) {
        ensureAuth(principal);
        User user = userService.getUser(principal);
        Post post = postService.getById(postId);
        opinionService.setOpinion(post, user, value);
    }

}
