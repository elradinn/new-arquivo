import React from "react";
import { Button } from "@mantine/core";
import { httpGet } from "@/Modules/Item/Helpers/http-helper";
import { usePage } from "@inertiajs/react";
import { IconDownload } from "@tabler/icons-react";

interface IProps {
    all?: boolean;
    ids?: string[];
    parentId?: string;
}

const DownloadFilesButton: React.FC<IProps> = ({ all, ids, parentId }) => {
    console.log({ all, ids, parentId });

    const download = () => {
        if (!all && ids?.length === 0) {
            return;
        }

        const p = new URLSearchParams();
        if (parentId) {
            p.append("parent_id", String(parentId));
        }

        if (all) {
            p.append("all", all ? "1" : "0");
        } else {
            ids?.forEach((id) => p.append("ids[]", id));
        }

        const url = route("item.download");

        httpGet(`${url}?${p.toString()}`).then((res) => {
            if (!res.url) {
                return;
            }

            const a = document.createElement("a");
            a.download = res.filename;
            a.href = res.url;
            a.click();
        });
    };

    return (
        <Button
            onClick={download}
            variant="subtle"
            color="dark.3"
            leftSection={<IconDownload size={18} />}
        >
            Download
        </Button>
    );
};

export default DownloadFilesButton;
