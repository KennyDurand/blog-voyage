module OS
    def OS.windows?
        (/cygwin|mswin|mingw|bccwin|wince|emx/ =~ RUBY_PLATFORM) != nil
    end

    def OS.mac?
        (/darwin/ =~ RUBY_PLATFORM) != nil
    end

    def OS.unix?
        !OS.windows?
    end

    def OS.linux?
        OS.unix? and not OS.mac?
    end
end

Vagrant.require_version ">= 1.9.0"

if not Vagrant.has_plugin? "vagrant-vbguest"
  system "vagrant plugin install vagrant-vbguest"
end
if not Vagrant.has_plugin? "vagrant-triggers"
  system "vagrant plugin install vagrant-triggers"
end
if OS.mac? and not Vagrant.has_plugin? "vagrant-bindfs"
  system "vagrant plugin install vagrant-bindfs"
end

Vagrant.configure("2") do |config|
    config.vm.define "blog-voyage" do |vm|
    end

    config.vm.provider :virtualbox do |v|
        v.name = "blog-voyage"
        v.memory = 2048
    end

    config.vm.box = "ubuntu/xenial64"
    config.vm.network :private_network, ip: "100.100.100.101"
    config.vm.synced_folder ".", "/var/www/blog-voyage", type: "nfs", create: true, :mount_options => ['actimeo=2']
    if OS.mac?
      config.bindfs.bind_folder "/var/www/blog-voyage", "/var/www/blog-voyage", {
        user: 'ubuntu',
        group: 'ubuntu'
      }
    end

    config.ssh.forward_agent = true

    config.vm.provision :ansible do |ansible|
        ansible.playbook = "provisioning/playbook.dev.yml"
        ansible.groups = {
            "dev" => ["blog-voyage"]
        }
    end

    config.trigger.after :up do
      system "open", "https://blog-voyage.wordpress.com/"
    end
end
