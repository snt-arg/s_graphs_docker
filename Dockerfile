FROM ros:noetic

ARG ssh_prv_key
ARG ssh_pub_key

RUN apt-get update && apt-get install -y --no-install-recommends \
    wget nano vim build-essential libomp-dev clang lld git\
    ros-noetic-geodesy ros-noetic-pcl-ros ros-noetic-nmea-msgs \
    ros-noetic-rviz ros-noetic-tf-conversions ros-noetic-libg2o \
    python3 python3-pip python3-vcstool git \
    openssh-server make cmake \
    libmysqlclient-dev

RUN pip3 install -U catkin_tools

# Authorize SSH Host
RUN mkdir -p /root/.ssh && \
    chmod 0700 /root/.ssh && \
    ssh-keyscan github.com > /root/.ssh/known_hosts

# Add the keys and set permissions
RUN echo "$ssh_prv_key" > /root/.ssh/id_rsa && \
    echo "$ssh_pub_key" > /root/.ssh/id_rsa.pub && \
    chmod 600 /root/.ssh/id_rsa && \
    chmod 600 /root/.ssh/id_rsa.pub

WORKDIR /root/.ssh/

# - Creating S-Graphs working space
RUN mkdir -p /root/s_graphs_ws/src
WORKDIR /root/s_graphs_ws/src
RUN git clone git@github.com:snt-arg/s_graphs.git && cd ./s_graphs && git checkout feature/s_graphs_2.0

# Remove SSH keys
RUN rm -rf /root/.ssh/

# - Installing S-Graphs dependencies
WORKDIR /root/s_graphs_ws/src/s_graphs
RUN vcs import --recursive ../ < .rosinstall

RUN rosdep update
WORKDIR /root/s_graphs_ws
RUN rosdep install --from-paths src --ignore-src -r -y

RUN catkin config --install && catkin build

# Remove SSH keys
RUN rm -rf /root/.ssh/
