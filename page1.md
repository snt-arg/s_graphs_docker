---
layout: default
title: Getting Started
rank: 1
---
<section class="section-pad">
<h1 class="title_section">{{page.title}}</h1>
<ol>
    <li>Clone <a href="https://github.com/snt-arg/s_graphs_docker"> this </a>repository
    </li>
    <li><p>Pull the docker image from DockerHub</p>
    </li>
<pre><code class="color-bg">docker pull sntarg/<span class="hljs-string">s_graphs:</span>latest
</code></pre>
    <li>Create a container for the s_graphs image.</li>

<pre><code class="color-bg">docker <span class="hljs-built_in">run</span> -dit <span class="hljs-comment">--net host --name s_graphs_container sntarg/s_graphs</span>
</code></pre>
<p>This command also incorporates the flags <code>d</code>, which makes the container run in the detached mode and <code>net</code>, which gives the container the access of the host interfaces.</p>
    <li>Execute the container</li>
<pre><code class="color-bg">docker <span class="hljs-built_in">exec</span> -ti s_graphs_container bash
</code></pre>
    <li>Source the s_graphs workspace</li>
<pre><code class="color-bg">source devel/<span class="hljs-built_in">setup</span>.bash
</code></pre>
</ol>
</section>
<hr>
<section class="section-pad">
<h2>Instructions To Use S-Graphs</h2>
<ol>
<li><p>Define the transformation between your sensors (LIDAR, IMU, GPS) and base_link of your system using static_transform_publisher (see line #94, s_graphs.launch). All the sensor data will be transformed into the common <code>base_link</code> frame, and then fed to the SLAM algorithm. Note: <code>base_link</code> frame in virtual dataset is set to <code>base_footprint</code> and in real dataset is set to <code>body</code> </p>
</li>
<li><p>Remap the point cloud topic of <strong><em>PrefilteringNodelet</em></strong>. Like:</p>
</li>
<pre><code class="color-bg">  &lt;node pkg=<span class="hljs-string">"nodelet"</span> <span class="hljs-built_in">type</span>=<span class="hljs-string">"nodelet"</span> <span class="hljs-built_in">name</span>=<span class="hljs-string">"hdl_prefilter"</span> args=<span class="hljs-string">"load s_graphs/PrefilteringNodelet hdl_prefilter_nodelet_manager"</span>&gt;
<br>
<span class="tab">
    &lt;remap</span> <span class="hljs-keyword">from</span>=<span class="hljs-string">"/velodyne_points"</span> <span class="hljs-keyword">to</span>=<span class="hljs-string">"/rslidar_points"</span>/&gt;
  ...
</code></pre>
<li>If you have an odometry source convert it to base ENU frame, then remove the <strong><em>ScanMatchingNodelet</em></strong> from line #37 to #50 in <code>s_graphs.launch</code> and then remap odom topic in <strong><em>SGraphsNodelet</em></strong> like </li>

<pre><code class="color-bg">  &lt;node pkg=<span class="hljs-string">"nodelet"</span> <span class="hljs-built_in">type</span>=<span class="hljs-string">"nodelet"</span> <span class="hljs-built_in">name</span>=<span class="hljs-string">"s_graphs"</span> args=<span class="hljs-string">"load s_graphs/SGraphsNodelet s_graphs_nodelet_manager"</span> output=<span class="hljs-string">"screen"</span>&gt; 
<br>
<span class="tab">
    &lt;remap </span> <span class="hljs-keyword">if</span>=<span class="hljs-string">"$(eval arg('env') == 'real')"</span> <span class="hljs-keyword">from</span>=<span class="hljs-string">"/odom"</span> <span class="hljs-keyword">to</span>=<span class="hljs-string">"/platform/odometry"</span> /&gt;
  ...
</code></pre>
<p>Note: If you want to visualize the tfs correctly then your odom source must provide a tf from the <code>odom</code> to <code>base_link</code> frame.  </p>
</ol>
</section>