import React from "react";
import { Button } from "@mantine/core";
import { httpGet } from "@/Modules/Item/Helpers/http-helper";
import { usePage } from "@inertiajs/react";
import { IconDownload } from "@tabler/icons-react";
import { PageProps } from "@/types";

interface IProps {
    all?: boolean;
    ids?: string[];
}

const DownloadFilesButton: React.FC<IProps> = ({ all, ids }) => {
    const parent_id = usePage<PageProps>().props.folder?.id;

    const download = () => {
        if (!all && ids?.length === 0) {
            return;
        }

        const p = new URLSearchParams();
        if (parent_id) {
            p.append("parent_id", String(parent_id));
        }

        if (all) {
            p.append("all", all ? "1" : "0");
        } else {
            ids?.forEach((id) => p.append("ids[]", id));
        }

        const url = route("file.download");

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
