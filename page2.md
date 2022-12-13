---
layout: default
title: Getting Started
rank: 2
---
<section class="card neumorphism-card-big">
1. Clone this repository

2. Pull the docker image from DockerHub

```sh
docker pull sntarg/s_graphs:latest
```

3. Create a container for the s_graphs image.

```sh
docker run -dit --net host --name s_graphs_container sntarg/s_graphs
```

This command also incorporates the flags `d`, which makes the container run in the detached mode and `net`, which gives the container the access of the host interfaces.

4. Execute the container

```sh
docker exec -ti s_graphs_container bash
```

5. Source the s_graphs workspace

```sh
source devel/setup.bash
```
</section>