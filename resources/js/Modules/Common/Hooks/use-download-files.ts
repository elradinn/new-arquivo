import { httpGet } from "@/Modules/Item/Helpers/http-helper";

interface DownloadFilesProps {
    all?: boolean;
    ids?: string[];
    parentId?: string;
}

export function useDownloadFiles() {
    const downloadFiles = ({ all, ids, parentId }: DownloadFilesProps) => {
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

    return { downloadFiles };
}