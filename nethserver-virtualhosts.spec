Name: nethserver-virtualhosts
Summary: Virtual hosts configuration
Version: 1.0.1
Release: 1%{?dist}
License: GPL
URL: %{url_prefix}/%{name} 
Source: %{name}-%{version}.tar.gz

BuildArch: noarch
Requires: nethserver-vsftpd, nethserver-httpd
BuildRequires: perl, perl(File::Path), nethserver-devtools

%description
Virtual hosts are public HTTP directories accessible using FTP.

%prep
%setup

%post

%build
%{makedocs}
perl createlinks

%install
rm -rf %{buildroot}
(cd root   ; find . -depth -print | cpio -dump %{buildroot})
%{genfilelist} %{buildroot} > %{name}-%{version}-%{release}-filelist

%clean 
rm -rf %{buildroot}

%files -f %{name}-%{version}-%{release}-filelist
%defattr(-,root,root)
%doc COPYING
%dir %{_nseventsdir}/%{name}-update
%config(noreplace) %ghost %attr (0644,root,root) %{_sysconfdir}/httpd/conf.d/virtualhosts.conf

%changelog
* Thu Sep 01 2016 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.0.1-1
- Apache vhost-default template expansion - NethServer/dev#5088

* Thu Jul 07 2016 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.0.0-1
- First NS7 release

