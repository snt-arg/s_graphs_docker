---
layout: default
title: Examples
rank: 2
---
<section class="section-pad">
    <h1 class="title_section">{{page.title}}</h1>
    <strong class="sec-space">Note:</strong> <em>Please execute the commands below in separate terminal windows!</em>
    <h2>Download Datasets</h2>
    <p class="sec-space"><a href="https://uniluxembourg-my.sharepoint.com/:u:/g/personal/hriday_bavle_uni_lu/EQN2qUn1P1dKuzcZqan8o3UBrBMa8b5Pcspupm_CBFHTgA?e=JxYnAJ" target="_blank">Real Dataset</a></p>
    <p class="sec-space"><a href="https://uniluxembourg-my.sharepoint.com/:u:/g/personal/hriday_bavle_uni_lu/EWy7dyDnGzFLh3LMR0VXYQABne9B_NZ0YCM-o_PF8PPY5g?e=xoThE1" target="_blank">Virtual Dataset</a></p>
    <h2>Real Dataset</h2>
    <code class="color-bg">
        <span class="hljs-built_in">cd</span> PATH_TO_THIS_REPO &amp;&amp; rviz <span class="hljs-_">-d</span> rviz/s_graphs.rviz
    </code>
    <p><strong>The next command run it inside the docker container!</strong></p>
    <pre><code class="color-bg">
            roslaunch s_graphs s_graphs.launch <span class="hljs-string">env:</span>=real <span class="hljs-string">use_free_space_graph:</span>=<span class="hljs-literal">true</span> <span class="hljs-number">2</span>&gt;<span class="hljs-regexp">/dev/</span><span class="hljs-literal">null</span>
    </code></pre>
    <code class="color-bg">
        rosbag PATH_TO_THIS_REPO/real_dataset <span class="hljs-comment">--clock</span>
    </code>
    <h2>Virtual Dataset</h2>
    <code class="color-bg">
        <span class="hljs-built_in">cd</span> PATH_TO_THIS_REPO &amp;&amp; rviz <span class="hljs-_">-d</span> rviz/s_graphs.rviz
    </code>
    <p><strong>The next command run it inside the docker container!</strong></p>
    <code class="color-bg">
        roslaunch s_graphs s_graphs.launch <span class="hljs-string">env:</span>=virtual <span class="hljs-string">use_free_space_graph:</span>=<span class="hljs-literal">true</span> <span class="hljs-number">2</span>&gt;<span class="hljs-regexp">/dev/</span><span class="hljs-literal">null</span>
    </code>
    <br>
    <code class="color-bg">
        rosbag play PATH_TO_THIS_REPO/virtual_dataset <span class="hljs-comment">--clock</span>
    </code>
    <h2>Dataset only using a Velodyne</h2>
    <code class="color-bg">
        roscd s_graphs &amp;&amp; rviz <span class="hljs-_">-d</span> rviz/s_graphs.rviz
    </code>
    <br>
    <code class="color-bg">
        roslaunch s_graphs s_graphs.launch <span class="hljs-string">use_free_space_graph:</span>=<span class="hljs-literal">true</span> <span class="hljs-string">compute_odom:</span>=<span class="hljs-literal">true</span> <span class="hljs-number">2</span>&gt;<span class="hljs-regexp">/dev/</span><span class="hljs-literal">null</span>
    </code>
    <br>
    <code class="color-bg">rosbag play PATH_TO_ROSBAG_DATASET <span class="hljs-comment">--clock</span>
    </code>
</section>