Name: nethserver-virtualhosts
Summary: Virtual hosts configuration
Version: 0.0.1
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
%{genfilelist} %{buildroot} \
    > %{name}-%{version}-%{release}-filelist
echo "%doc COPYING"          >> %{name}-%{version}-%{release}-filelist

%clean 
rm -rf %{buildroot}

%files -f %{name}-%{version}-%{release}-filelist
%defattr(-,root,root)
%dir %{_nseventsdir}/%{name}-update


%changelog
