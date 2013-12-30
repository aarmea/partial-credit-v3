#
# Cookbook Name:: jasig_cas
# Recipe:: default
#
# Copyright 2013, Albert Armea
#

include_recipe "php::pear"

command = "pear install http://downloads.jasig.org/cas-clients/php/current.tgz"

bash "dowload_jasig_cas" do
  cwd "#{Chef::Config[:file_cache_path]}"
  code <<-EOH
    #{command}
  EOH
end
