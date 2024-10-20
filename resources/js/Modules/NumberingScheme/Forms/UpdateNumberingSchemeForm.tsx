import { Modal, Text, TextInput, Button, Stack, Flex } from "@mantine/core";
import { useUpdateNumberingScheme } from "../Hooks/use-update-numbering-scheme";
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";
import { ItemParentResourceData } from "@/Modules/Item/Types/ItemParentResourceData";

interface IProps {
    itemParent?: ItemParentResourceData;
}

export const UpdateNumberingSchemeForm: React.FC<IProps> = ({
    itemParent,
}) => {
    const { modals, closeModal } = useModalStore();
    const isOpen = modals["updateNumberingScheme"];

    const { data, setData, handleSubmit, processing, errors } = useUpdateNumberingScheme({
        itemParent,
        isOpen,
    });

    return (
        <Modal
            opened={isOpen}
            onClose={() => closeModal("updateNumberingScheme")}
            title={<Text size="lg">Update Numbering Scheme</Text>}
            size={550}
        >
            <form onSubmit={handleSubmit}>
                <Stack gap={16}>
                    <TextInput
                        label="Name"
                        value={data.name}
                        onChange={(e) => setData("name", e.target.value)}
                        error={errors.name}
                    />
                    <TextInput
                        label="Prefix"
                        value={data.prefix}
                        onChange={(e) => setData("prefix", e.target.value)}
                        error={errors.prefix}
                    />
                </Stack>
                <Flex align="center" justify="end" mt={16}>
                    <Button variant="light" onClick={() => closeModal("updateNumberingScheme")}>
                        Cancel
                    </Button>
                    <Button ml={12} type="submit" loading={processing}>
                        Update
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};
