# The SnowTricks community site-Projet-6

this porject is created as part of a PHP / Symfony application developer training, without using any bundle,

## General idea around project
<p>Jimmy Sweat is an ambitious entrepreneur passionate about snowboarding. Its goal is to create a collaborative website to make the sport known to the general public and help to learn tricks.</p>

<p>It wants to capitalize on content brought by Internet users to develop rich content and arousing the interest of users of the site. Subsequently, Jimmy wants to develop a relationship business with snowboard brands thanks to the traffic that the content will have generated.</p>

# The quality of the code

<a href="https://codeclimate.com/github/samirdev2019/SnowTricks/maintainability"><img src="https://api.codeclimate.com/v1/badges/6063d0f2e9f3c6df3c51/maintainability" /></a>
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/27c4a10d87924d29bbe0b6528ccdb3a6)](https://www.codacy.com/app/samirdev2019/SnowTricks?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=samirdev2019/SnowTricks&amp;utm_campaign=Badge_Grade)

# How to install the project

<h4>1 - Download or clone the repository git</h4>
<pre><code>git@github.com:samirdev2019/SnowTricks.git</pre></code>

<h4>2 - Download dependencies :</h4>
<pre><code>composer install</pre></code> 

<h4>3 - Create database :</h4>
<pre><code>php bin/console doctrine:database:create</pre></code>

<h4>4 - Create schema :</h4>
<pre><code>php bin/console doctrine:schema:update --force</pre></code>

<h4>5 - Load fixtures :</h4>
<pre><code>php bin/console doctrine:fixtures:load</pre></code>

<h4>6 - Run the server :</h4>
<pre><code>PHP -S localhost:8080</pre></code>
<h4>7- User registred:</h>
<p>username : username</p>
<p>password : demo </p>






