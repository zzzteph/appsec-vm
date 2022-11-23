    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" context="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>Fast File Finder</title>
        <link rel="stylesheet" href="/css/all.css">
        <link href="/css/bulma.css" rel="stylesheet">
    </head>

    <body>

        <div class="container">
            <section class="articles">
                <div class="column is-8 is-offset-2">
                    <div class="card article">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-content has-text-centered">
                                    <p class="title article-title">Fast file finder with find!</p>
									 <p>You can search for specific filename by typing it in search form (for example *.php)</p>
									
                                    <form action="/" method="post" accept-charset="utf-8">
                                        <div class="field has-addons">
                                            <p class="control is-expanded">
                                                <input type="text" name="filename" value="" class="input" />
                                            </p>
                                            <div class="control">
                                                <input type="submit" value="Search" class="button is-primary" />
                                            </div>
                                        </div>
                                </div>
                            </div>
							</form>
                            <div class="content article-body">
							<%
							String output = (String) request.getAttribute("output");

							if(output!=null)out.println(output);		

							%>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </body>

    </html>