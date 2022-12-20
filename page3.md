---
layout: default
title: Wiki
rank: 3
---
<section class="section-pad">
<h3 id="nodelets">Nodelets</h3>
<blockquote>
<p>s_graphs is composed of <strong>3</strong> main nodelets.</p>
</blockquote>
<ul>
<li><p><strong>s_graphs_nodelet</strong></p>
<ul>
<li><p>Subscribed Topics</p>
<ul>
<li><code>/odom</code> (<a href="http://docs.ros.org/en/noetic/api/nav_msgs/html/msg/Odometry.html">nav_msgs/Odometry</a>)<ul>
<li>The odometry from the robot.</li>
</ul>
</li>
<li><code>/filtered_points</code> (<a href="http://docs.ros.org/en/melodic/api/sensor_msgs/html/msg/PointCloud2.html">sensor_msgs/PointCloud2</a>)<ul>
<li>The data from the Lidar sensor.</li>
</ul>
</li>
</ul>
</li>
<li><p>Published Topics</p>
<ul>
<li><code>/s_graphs/markers</code> (<a href="http://docs.ros.org/en/noetic/api/visualization_msgs/html/msg/MarkerArray.html">visualization_msgs/MarkerArray</a>)<ul>
<li>The markers represents the different s_graphs layers.</li>
</ul>
</li>
<li><code>/s_graphs/odom2map</code> (<a href="http://docs.ros.org/en/api/geometry_msgs/html/msg/TransformStamped.html">geometry_msgs/TransformStamped</a>)<ul>
<li>Sets where the robot pose is within the map (world).</li>
</ul>
</li>
<li><code>/s_graphs/odom_pose_corrected</code> (<a href="http://docs.ros.org/en/noetic/api/geometry_msgs/html/msg/PoseStamped.html">geometry_msgs/PoseStamped</a>)<ul>
<li>The pose of the robot once odom2map is applied.</li>
</ul>
</li>
<li><p><code>/s_graphs/odom_path_corrected</code> (<a href="http://docs.ros.org/en/noetic/api/nav_msgs/html/msg/Path.html">nav_msgs/Path</a>)</p>
<ul>
<li>The path of the robot once the odom2map is applied.</li>
</ul>
</li>
<li><p><code>/s_graphs/map_points</code> (<a href="http://docs.ros.org/en/melodic/api/sensor_msgs/html/msg/PointCloud2.html">sensor_msgs/PointCloud2</a>)</p>
<ul>
<li>The points that represent the first layer of S-Graphs.</li>
</ul>
</li>
<li><code>/s_graphs/map_planes</code> (s_graphs/PlanesData)<ul>
<li>Current planes seen by the robot.</li>
</ul>
</li>
<li><code>/s_graphs/all_map_planes</code> (s_graphs/PlanesData)<ul>
<li>All the planes that were seen by the robot.</li>
</ul>
</li>
</ul>
</li>
</ul>
</li>
<li><p><strong>room_segmentation_nodelet</strong></p>
<ul>
<li><p>Subscribed Topics</p>
<ul>
<li><code>/voxblox_skeletonizer/sparse_graph</code> (<a href="http://docs.ros.org/en/noetic/api/visualization_msgs/html/msg/MarkerArray.html">visualization_msgs/MarkerArray</a>)<ul>
<li>Represents the free space where the robot can go to. This is also knonw as free-space clusters.</li>
</ul>
</li>
<li><code>/s_graphs/map_planes</code> (s_graphs/PlanesData)<ul>
<li>Current planes seen by the robot.</li>
</ul>
</li>
</ul>
</li>
<li><p>Published Topics</p>
<ul>
<li><code>/room_segmentation/room_data</code> (s_graphs/RoomsData)<ul>
<li>Contains all the necessary information about the rooms in a floor.</li>
</ul>
</li>
</ul>
</li>
</ul>
</li>
<li><p><strong>floor_plane_nodelet</strong></p>
<ul>
<li><p>Subscribed Topics</p>
<ul>
<li><code>/s_graphs/all_map_planes</code> (s_graphs/PlanesData)<ul>
<li>All the planes that were seen by the robot.</li>
</ul>
</li>
</ul>
</li>
<li><p>Published Topics</p>
<ul>
<li><code>/floor_plan/floor_data</code> (s_graphs/RoomData):<ul>
<li>Constains all the necessary information about each floor.</li>
</ul>
</li>
</ul>
</li>
</ul>
</li>
</ul>
<h3 id="services">Services</h3>
<ul>
<li><p><code>/s_graphs/dump</code> (s_graphs/DumpGraph)</p>
<ul>
<li>save all the internal data (point clouds, floor coeffs, odoms, and pose graph) to a directory.</li>
</ul>
</li>
<li><p><code>/s_graphs/save_map</code> (s_graphs/SaveMap)</p>
<ul>
<li>save the generated map as a PCD file.</li>
</ul>
</li>
</ul>
<h3 id="parameters">Parameters</h3>
<p>All the configurable parameters are listed in _launch/s<em>graphs.launch</em> as ros params.</p>
<h3 id="published-tfs">Published TFs</h3>
<ul>
<li><code>map2odom</code>: The transform published between the map frame and the odom frame after the corrections have been applied.</li>
</ul>
<div class="gif-layout">
    <img src="https://raw.githubusercontent.com/snt-arg/s_graphs_docker/feature/webpage/assets/img/Tf-tree.png" alt="Tf Tree" width="90%">
</div>
</section>