---
layout: default
title: Example on Datasets
rank: 3
---
<section class="card neumorphism-card-big">
**Note:** For each command below, please execute them in separate terminal windows!

### Download Datasets

[Real Dataset](https://uniluxembourg-my.sharepoint.com/:u:/g/personal/hriday_bavle_uni_lu/EQN2qUn1P1dKuzcZqan8o3UBrBMa8b5Pcspupm_CBFHTgA?e=JxYnAJ)

[Virtual Dataset](https://uniluxembourg-my.sharepoint.com/:u:/g/personal/hriday_bavle_uni_lu/EWy7dyDnGzFLh3LMR0VXYQABne9B_NZ0YCM-o_PF8PPY5g?e=xoThE1)

### Real Dataset

```bash
cd PATH_TO_THIS_REPO && rviz -d rviz/s_graphs.rviz
```

**The next command run it inside the docker container!**

```bash
roslaunch s_graphs s_graphs.launch env:=real use_free_space_graph:=true 2>/dev/null
```

```bash
rosbag PATH_TO_THIS_REPO/real_dataset --clock
```

### Virtual Dataset

```bash
cd PATH_TO_THIS_REPO && rviz -d rviz/s_graphs.rviz
```

**The next command run it inside the docker container!**

```bash
roslaunch s_graphs s_graphs.launch env:=virtual use_free_space_graph:=true 2>/dev/null
```

```bash
rosbag play PATH_TO_THIS_REPO/virtual_dataset --clock
```

### Dataset only using a Velodyne

```bash
roscd s_graphs && rviz -d rviz/s_graphs.rviz
```

```bash
roslaunch s_graphs s_graphs.launch use_free_space_graph:=true compute_odom:=true 2>/dev/null
```

```bash
rosbag play PATH_TO_ROSBAG_DATASET --clock
```

</section>