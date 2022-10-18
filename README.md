## S-Graphs Docker Image

This docker image contains the the s_graphs ROS workspace installed for the ease of use of the software.

## Getting started

1. Pull the docker image from DockerHub

```sh
docker pull sntarg/s_graphs:latest
```

2. Create a container for the s_graphs image.

```sh
docker run -dit --net host --name s_graphs_container sntarg/s_graphs
```

This command also incorporates the flags `d`, which makes the container run in the detached mode and `net`, which gives the container the access of the host interfaces.

3. Execute the container

```sh
docker exec -ti s_graphs_container bash
```

4. Source the s_graphs worspace

```sh
source devel/setup.bash
```
