#!/bin/bash

echo "🧹 Starting Mac cleanup..."

# checiking system foldr
sudo du -hxd1 /System/Volumes/Data | sort -h

# checking user folder
du -hxd1 ~ | sort -h

rm -rf ~/Library/Caches/*
rm -rf ~/Library/Logs/*

npm cache clean --force 2>/dev/null
rm -rf ~/.cache

rm -rf ~/Library/Application\ Support/Code/CachedData
rm -rf ~/Library/Application\ Support/Code/User/workspaceStorage

rm -rf ~/Library/Application\ Support/Google/Chrome/Profile\ 1/Cache/*
rm -rf ~/Library/Application\ Support/Google/Chrome/Profile\ 1/Code\ Cache/*
rm -rf ~/Library/Application\ Support/Google/Chrome/Profile\ 1/GPUCache/*

rm -rf ~/Library/Containers/com.tinyspeck.slackmacgap/Data/Library/Caches/*

rm -rf ~/Library/Application\ Support/Postman/Cache
rm -rf ~/Library/Application\ Support/Figma/Cache
rm -rf ~/Library/Application\ Support/discord/Cache/*

rm -rf ~/Library/Trial/*
rm -rf ~/Library/ScreenRecordings/*
rm -rf ~/Library/Application\ Support/Caches/*

echo "✅ Cleanup complete. Restart your Mac for best results."